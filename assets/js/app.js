import Vue from 'vue';
import CreateModal from '../vue/TodoList/CreateModal.vue';
import TodoList from '../vue/TodoList/TodoList';

// start app
new Vue({
    el: '#app',
    props: ['dataUrlLists'],
    data: {
        showModal: false,
        todoLists: []
    },
    components: {
        'modal': CreateModal,
        'todo-list': TodoList
    },
    methods: {
       loadTodoLists: function() {
           console.log(this.dataUrlLists);

           fetch('/list').then((response) => {
               var contentType = response.headers.get("content-type");
               if (response.ok === false) {
                   console.log('oups', response);
               }

               if (response.status === 200) {
                   if (contentType && contentType.indexOf("application/json") !== -1) {
                       return response.json().then((json) => {
                           for (var i = 0, len = json.length; i < len; i++) {
                               this.todoLists.push(json[i]);
                           }
                        })
                   }
               }
           }).catch((err) => {
                console.log('oups', err);
           })
        }
    },
    mounted () {
        console.log('app mounted, loading todolists...')

        this.loadTodoLists();
    }
})