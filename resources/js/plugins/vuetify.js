import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import 'vuetify/dist/vuetify.min.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const customDarkTheme = {
    dark: true,
    colors: {

    },
};

const customLightTheme = {
    dark: false,
    colors: {

    },
};

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'light',
        themes: {
            light: customLightTheme,
            dark: customDarkTheme,
        },
    },

})

export default vuetify
