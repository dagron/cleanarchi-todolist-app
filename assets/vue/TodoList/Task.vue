<template>
    <li class="task">
        <p>{{ description }}</p>
    </li>
</template>


<script>
    export default {
        name: 'Task',
        props: ['task'],
        methods: {},
        mounted () {
            console.log('task initialized')
        }
    }
</script>