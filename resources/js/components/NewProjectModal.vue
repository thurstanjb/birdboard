<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl">Lets Start Something New</h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label class="text-sm block mb-2" for="title">Title</label>
                        <input type="text" id="title"
                               name="title"  v-model="form.title"
                               class="bg-card text-default border border-muted-light p-2 text-xs block w-full rounded"
                               :class="form.errors.title ? 'border-error' : 'border-muted-light'"
                        >
                        <ul v-if="form.errors.title" class="text-error mt-1 text-xs italic">
                            <li v-for="error in form.errors.title">
                                {{error}}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <label class="text-sm block mb-2" for="description">Description</label>
                        <textarea id="description" name="description"
                                  class="bg-card text-default border border-muted-light p-2 text-xs block w-full rounded"
                                  rows="7" v-model="form.description"
                                  :class="form.errors.description ? 'border-error' : 'border-muted-light'"></textarea>
                        <ul v-if="form.errors.description" class="text-error mt-1 text-xs italic">
                            <li v-for="error in form.errors.description">
                                {{error}}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="text-sm block mb-2">Need some tasks?</label>
                        <input type="text" v-for="task in form.tasks"
                               class="bg-card text-default border border-muted-light p-2 text-xs block w-full rounded mb-2"
                               placeholder="Enter your task..."
                               v-model="task.body"
                        >
                    </div>

                    <button type="button" class="inline-flex items-center text-xs" @click="addTask">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                            <g fill="none" fill-rule="evenodd" opacity=".307">
                                <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                            </g>
                        </svg>

                        <span>Add New Task Field</span>
                    </button>
                </div>
            </div>
            <footer class="flex justify-end">
                <button type="button" class="button is-outlined mr-2" @click="cancel">Cancel</button>
                <button class="button">Create Project</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    import BirdboardForm from './BirdboardForm';
    export default {
      data(){
        return {
          form: new BirdboardForm({
            title: '',
            description: '',
            tasks: [
              {body: ''}
            ]
          }),
          new_task: {
            body: ''
          }
        }
      },

      methods: {
        addTask(){
          this.form.tasks.push(_.clone(this.new_task));
        },
        cancel(){
          this.form.reset();
          this.$modal.hide('new-project')
        },
        submit(){
          if(! this.form.tasks[0].body){
            delete this.form.originalData.tasks;
          }

          this.form.submit('/projects')
            .then(response => {
                location = response.data.message;
            })
        }
      }
    }
</script>
