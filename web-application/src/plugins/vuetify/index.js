import { createVuetify } from 'vuetify'
import { VDateInput } from 'vuetify/labs/VDateInput'
import { VNumberInput } from 'vuetify/labs/VNumberInput'
import { VBtn } from 'vuetify/components/VBtn'
import { VFab } from 'vuetify/labs/VFab'
import defaults from './defaults'
import { icons } from './icons'
import theme from './theme'

// Styles
import '@core/scss/template/libs/vuetify/index.scss'
import 'vuetify/styles'

export default createVuetify({
  components: {
    VFab,
    VDateInput,
    VNumberInput,
  },
  aliases: {
    IconBtn: VBtn,
  },
  defaults,
  icons,
  theme,
})
