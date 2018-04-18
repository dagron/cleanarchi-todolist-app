import Vue from 'vue';
import CreateModal from '../vue/TodoList/CreateModal.vue';

// register modal component
Vue.component('modal', {
    template: '#modal-template'
})

// start app
new Vue({
    el: '#app',
    data: {
        showModal: false
    },
    components: {
        'modal': CreateModal
    }
})