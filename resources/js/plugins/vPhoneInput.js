import 'flag-icons/css/flag-icons.min.css';
import 'v-phone-input/dist/v-phone-input.css';
import { createVPhoneInput } from 'v-phone-input';

const vPhoneInput = createVPhoneInput({
    countryIconMode: 'svg',
    includeCountries: [
        'AM', 'US', 'FR', 'RU'
    ]
});

export default vPhoneInput
