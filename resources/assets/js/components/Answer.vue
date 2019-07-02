<script>
export default {
  props: ["answer"],

  data() {
    return {
      editing: false,
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditingCache: null
    };
  },

  methods: {
    edit() {
      this.beforeEditingCache = this.body;
      this.editing = true;
    },

    cancel() {
      this.body = this.beforeEditingCache;
      this.editing = false;
    },
    update() {
      axios
        .patch(this.endpoint, {
          body: this.body
        })
        .then(res => {
          this.editing = false;
          this.bodyHtml = res.data.body_html;
          alert(res.data.message);
        })
        .catch(err => {
          alert(err.response.data.message);
        });
    },
    destroy() {
      if (confirm("Are you sure to delete this answer?")) {
        axios.delete(this.endpoint).then(res => {
          $(this.$el).fadeOut(500, () => {
            alert(res.data.message);
          });
        });
      }
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
