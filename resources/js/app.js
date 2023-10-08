import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'
import { mdiAccount } from '@mdi/js'
import { Link } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Icon } from '@iconify/vue';


const vuetify = createVuetify({
  components,
  directives,

  icons: {
    defaultSet: 'mdi', // This is already the default value - only for display purposes
  },


})


createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify)
      .use(ZiggyVue, Ziggy)
      .component('Icon',Icon)
      .component('Link',Link)
      .mount(el)
  },
})