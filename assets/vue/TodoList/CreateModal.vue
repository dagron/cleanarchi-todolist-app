<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h3>Create a TodoList</h3>
                    </div>

                    <div class="modal-body">
                        <form :action="formUrl" method="post">
                            <label for="createTitle">Title</label>
                            <input class="u-full-width" id="createTitle" name="title" type="text" required />
                            <button class="button" v-on:click.prevent="close()">Cancel</button>
                            <input class="button-primary" type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>


<script>
export default {
    name: 'CreateModal',
    props: ['formUrl'],
    data () {
        return {
        }
    },
    methods: {
        close () {
            this.$emit('close');
        }
    },
    mounted () {
        document.querySelector('#createTitle').focus()
    }
}
</script>