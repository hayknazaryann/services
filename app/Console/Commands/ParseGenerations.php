<?php

namespace App\Console\Commands;

use App\Enums\MarketsEnum;
use App\Models\CarModel;
use App\Models\Generation;
use App\Repositories\Interfaces\GenerationInterface;
use App\Services\ClientService;
use Exception;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ParseGenerations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-generations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var ClientService
     */
    protected ClientService $service;

    /**
     * @param GenerationInterface $generationRepository
     */
    public function __construct(
        protected GenerationInterface $generationRepository
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = CarModel::all();
        if (count($models)) {
            $this->service = (new ClientService())
                ->setOptions(['cookies' => CookieJar::fromArray(['socnetchck' => 1], 'drom.ru')]);

            try {
                $this->info('Start parsing generations');
                foreach ($models as $model) {
                    $url = $model->link;
                    $modelId = $model->id;
                    $crawler = $this->service->getCrawler($url);
                    $markets = $crawler->filter('.css-pyemnz');
                    if ($markets->count()) {
                        $markets->each(function (Crawler $node, $i) use ($url, $modelId) {
                            $market = $node->filter('.css-112idg0.e1ei9t6a3')->attr('id');
                            $cars = $node->filter('a.e1ei9t6a1');
                            if ($cars->count()) {
                                $cars->each(function (Crawler $node, $i) use ($market, $url, $modelId) {
                                    $data = [];
                                    $caption = $node->filter('.e1ei9t6a2')->innerText();
                                    $captionData = $this->getTitleAndPeriod($caption);
                                    $data['model_id'] = $modelId;
                                    $data['market'] = MarketsEnum::getByKey($market);
                                    $title = $captionData['title'];
                                    $data['title'] = $title;
                                    $info = $node->filter('[data-ftid="component_article_extended-info"]');
                                    $generation = $info->children()->count() ? $info->children()->first()->innerText() : null;
                                    $data['generation'] = $generation;
                                    $period = $captionData['period'];
                                    $data['period'] = $period;
                                    $data['image'] = $node->filter('img.evrha4s0')->attr('src');
                                    $data['link'] = $url . $node->attr('href');

                                    $this->generationRepository->updateOrCreate(
                                        ['link' => $data['link']],
                                        $data
                                    );
                                    $this->info("{$title} {$period} {$generation} parsed");
                                });
                            }
                        });
                    }
                }
                $this->info('End parsing generations');
            } catch (Exception $e) {
                $this->error('Something went wrong');
                return;
            }

        } else {
            $this->error('Models not found');
        }

    }


    /**
     * @param $inputString
     * @return array
     */
    private function getTitleAndPeriod($inputString): array
    {
        $pattern = '/^(.+) (\d{2}\.\d{4}) - (\d{2}\.\d{4}|н\.в\.)$/u';

        if (preg_match($pattern, $inputString, $matches)) {
            $title = $matches[1];
            $startDate = $matches[2];
            $endDate = $matches[3];
            return [
                'title' => $title,
                'period' => $startDate . ' - ' . $endDate
            ];
        } else {
            return [
                'title' => $inputString,
                'period' => null
            ];
        }
    }
}
