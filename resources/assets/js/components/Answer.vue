<template>
  <div class="media post">
    <vote :model="answer" name="answer"></vote>

    <div class="media-body">
      <form v-if="editing" @submit.prevent="update">
        <div class="form-group">
          <textarea rows="10" v-model="body" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary" :disabled="isInvalid">Update</button>
        <button class="btn btn-outline-secondary" type="button" @click="cancel">Batal</button>
      </form>
      <div v-else>
        <div v-html="bodyHtml"></div>
        <div class="row">
          <div class="col-4">
            <a
              v-if="authorize('modify', answer)"
              @click.prevent="edit"
              class="btn btn-outline-info btn-sm"
            >Edit</a>
            <button
              v-if="authorize('modify', answer)"
              @click="destroy"
              class="btn btn-sm btn-outline-danger"
            >Hapus</button>
          </div>
          <div class="col-4"></div>
          <div class="col-4">
            <user-info :model="answer" label="Dijawab"></user-info>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from "./Vote.vue";
import UserInfo from "./UserInfo.vue";
import mixed from "../mixins/mixed";

export default {
  props: ["answer"],

  components: { Vote, UserInfo },

  mixins: [mixed],

  data() {
    return {
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditingCache: null
    };
  },

  methods: {
    setEditCache() {
      this.beforeEditingCache = this.body;
    },

    restoreFromCache() {
      this.body = this.beforeEditingCache;
    },

    payload() {
      return {
        body: this.body
      };
    },

    delete() {
      axios.delete(this.endpoint).then(res => {
        this.$toast.success(res.data.message, "Sukses", { timeout: 2000 });
        this.$emit("deleted");
      });
    }
  },

  computed: {
    isInvalid() {
      return this.body.length < 10;
    },
    endpoint() {
      return `/questions/${this.questionId}/answers/${this.id}`;
    }
  }
};
</script>
