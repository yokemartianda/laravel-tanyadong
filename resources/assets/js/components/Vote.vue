<template>
  <div class="d-flex flex-column vote-controls">
    <a @click.prevent="voteUp" :title="title('up')" class="vote-up" :class="classes">
      <i class="fas fa-caret-up fa-3x"></i>
    </a>

    <span class="votes-count">{{ count }}</span>

    <a @click.prevent="voteDown" :title="title('down')" class="vote-down" :class="classes">
      <i class="fas fa-caret-down fa-3x"></i>
    </a>

    <accept v-if="name == 'answer'" :answer="model"></accept>
    <favorite v-else :question="model"></favorite>
  </div>
</template>

<script>
import Favorite from "./Favorite.vue";
import Accept from "./Accept.vue";

export default {
  props: ["name", "model"],

  computed: {
    classes() {
      return this.signedIn ? "" : "off";
    },

    endpoint() {
      return `/${this.name}s/${this.id}/vote`;
    }
  },

  components: {
    Favorite,
    Accept
  },

  data() {
    return {
      count: this.model.votes_count || 0,
      id: this.model.id
    };
  },

  methods: {
    title(voteType) {
      let titles = {
        up:
          this.name == "answer"
            ? "Jawaban ini membantu"
            : "Pertanyaan ini membantu",
        down:
          this.name == "answer"
            ? "Jawaban ini tidak membantu"
            : "Pertanyaan ini tidak membantu"
      };

      return titles[voteType];
    },

    voteUp() {
      this._vote(1);
    },

    voteDown() {
      this._vote(-1);
    },

    _vote(vote) {
      if (!this.signedIn) {
        this.$toast.warning(
          `Mohon login untuk vote ${this.name}`,
          "Warning",
          {
            timeout: 3000,
            position: "bottomLeft"
          }
        );

        return;
      }
      axios.post(this.endpoint, { vote }).then(res => {
        this.$toast.success(res.data.message, "Sukses", {
          timeout: 3000,
          position: "bottomLeft"
        });

        this.count = res.data.votesCount;
      });
    }
  }
};
</script>
