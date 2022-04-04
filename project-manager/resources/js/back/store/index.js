import Vuex from 'vuex';
import Vue from 'vue';

import user from './modules/user.js';
// import settings from './modules/settings';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user
    }
});
