<template>
    <transition name="modal">
        <div class="modal-mask"">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h3>Create a TodoList</h3>
                    </div>

                    <div class="alert" v-if="alertMessage">
                        <h6 v-if="alertTitle">{{ alertTitle }}</h6>
                        <p>{{ alertMessage }}</p>
                    </div>
                    <div class="alert error" v-else-if="errorMessage">
                        <h6>Oops!</h6>
                        <p>{{ errorMessage }}</p>
                    </div>

                    <div class="modal-body">
                        <form :action="formUrl" method="post" v-on:submit.prevent="submit()" id="createForm">
                            <label for="createTitle">Title</label>
                            <input v-bind:readonly="disabled" v-bind:disabled="disabled" @keyup.esc="close()" @keydown.enter.prevent="submit()" class="u-full-width" id="createTitle" name="title" type="text" required />
                            <button class="button" v-on:click.prevent="close()">Cancel</button>
                            <button v-bind:disabled="disabled" class="button-primary u-pull-right" type="submit">Submit</button>
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
            disabled: false,
            alertMessage: null,
            alertTitle: null,
            errorMessage: null
        }
    },
    methods: {
        close () {
            this.$emit('close')
        },
        submit () {
            this.errorMessage = null;
            this.alertMessage = 'Please wait...';
            this.disabled = true;
            var form = document.querySelector('#createForm');

            fetch(form.getAttribute('action'), {
                method: 'post',
                body: new URLSearchParams(new FormData(form))
            }).then((response) => {
                var contentType = response.headers.get("content-type");
                this.disabled = false;
                if (response.ok === false) {
                    this.alertMessage = null;
                    if(contentType && contentType.indexOf("application/json") !== -1) {
                        return response.json().then((json) => {
                            this.errorMessage = json.errors.join(', ')
                        })
                    }

                    this.errorMessage = response.statusText
                    return
                }

                if (response.status === 200) {
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        return response.json().then((json) => {
                            console.log('created list', json.list.title)
                        })
                    }
                }

                this.close()
            }).catch((err) => {
                this.disabled = false;
                this.alertMessage = null;
                this.errorMessage = 'Something bad happened with fetch()';
            })
        }
    },
    mounted () {
        document.querySelector('#createTitle').focus()
    }
}
</script>