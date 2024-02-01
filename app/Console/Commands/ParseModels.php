<?php

namespace App\Console\Commands;

use App\Models\CarModel;
use App\Repositories\Interfaces\ModelInterface;
use App\Services\ClientService;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ParseModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-models';

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
     * @param ModelInterface $modelRepository
     */
    public function __construct(
        protected ModelInterface $modelRepository
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service = (new ClientService())
            ->setOptions(['cookies' => CookieJar::fromArray(['socnetchck' => 1], 'drom.ru')]);

        try {
            $this->info('Start parsing Models');
            $crawler = $this->service->getCrawler('https://www.drom.ru/catalog/audi/');
            $crawler->filter('.ehmqafe0 > .exkrjba0')->each(function (Crawler $node, $i) {
                $node->filter('a.e64vuai0')->each(function (Crawler $node, $i) {
                    $title = $node->innerText();
                    $link = $node->attr('href');
                    $this->modelRepository->updateOrCreate(
                        ['link' => $link],
                        [
                            'title' => $title,
                            'link' => $link
                        ]
                    );
                    $this->info("Model {$title} parsed");
                });
            });
            $this->info('End parsing Models');
        } catch (\Exception $e) {
            $this->error('Something went wrong');
            return;
        }
    }
}
