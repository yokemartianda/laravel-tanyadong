<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        @include('shared._vote', [
            "model" => $answer
        ])
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control"></textarea>
                </div>
                <button @click.prevent="editing = false">Update</button>
                <button @click.prevent="editing = false">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        @can('update', $answer)
                        <a @click.prevent="editing = true" class="btn btn-outline-info btn-sm">Edit</a>
                        @endcan
        
                        @can('delete', $answer)
                        <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST" class="form-delete">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to delete this question?')">Delete</button>
                        </form>
                        @endcan
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>