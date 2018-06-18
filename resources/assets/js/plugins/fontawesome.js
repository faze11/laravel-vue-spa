import Vue from 'vue'
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

import {
    faUser, faLock, faSignOutAlt, faCog
} from '@fortawesome/fontawesome-free-solid/shakable.es'

import {
    faGithub, faInstagram, faFacebookF, faTwitter, faYoutube
} from '@fortawesome/fontawesome-free-brands/shakable.es'

fontawesome.library.add(
    faUser, faLock, faSignOutAlt, faCog, faGithub, faInstagram, faFacebookF, faTwitter, faYoutube
)

Vue.component('fa', FontAwesomeIcon)
