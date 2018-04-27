<template>
    <li class="todolist six columns">
        <h3><span class="u-pull-right"><a href="#" class="todolist-remove">x</a></span> {{ list.title }}</h3>
        <ul class="tasks" v-if="list.tasks">
            <task v-for="task in list.tasks"
                  :task="task"
                  :key="task.id"
            />
        </ul>
    </li>
</template>


<script>
    import Task from './Task.vue';

    export default {
        name: 'TodoList',
        props: ['list'],
        components: {
           'task': Task
        },
        methods: {},
        mounted () {
            console.log('todolist mounted: '+ this.list.id)
        }
    }
</script>