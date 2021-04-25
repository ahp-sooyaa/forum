<template>
  <div class="mb-3">
    <div v-if="$signIn">
      <div
        class="mx-auto bg-gray-700 shadow-md p-5 rounded-3xl"
      >
        <div class="flex items-center text-white font-semibold mb-3">
          <svg
            class="w-4 h-4 mr-2"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
            />
          </svg>
          Reply to
        </div>
        <hr class="border border-gray-500" />
        <div class="mb-3">
          <textarea
            id="body"
            name="body"
            rows="6"
            class="text-white border-0 focus:ring-0 block w-full sm:text-sm bg-gray-700 px-0"
            v-model="body"
          ></textarea>
        </div>
        <button @click="addReply" class="btn-indigo text-sm">Post</button>
        <button @click="isOpen = false" class="btn-outline-indigo text-sm">
          Cancel
        </button>
      </div>
    </div>
    <div v-else class="text-center">
      Please <a href="/login">Login</a> to participate in forum discussion!
    </div>
  </div>
</template>

<script>
import Tribute from "tributejs";
export default {
  data() {
    return {
      isOpen: false,
      body: "",
      endPoint: location.pathname + "/replies",
    };
  },

//   created() {
//     window.events.$on("reply", this.openModal);
//   },

  mounted() {
    let tribute = new Tribute({
      // column to search against in the object (accepts function or string)
      lookup: "value",
      // column that contains the content to insert by default
      fillAttr: "value",
      values: function (query, cb) {
        axios.get("/api/users", { params: { name: query } })
          .then(function (response) {
            console.log(response);
            cb(response.data);
          });
      },
    });
    tribute.attach(document.querySelectorAll("#body"));
  },

  methods: {
    addReply() {
      axios
        .post(this.endPoint, { body: this.body })
        .catch((error) => {
          this.isOpen = false;
          this.body = "";

          flash(error.response.data.message, "red");
        })
        .then(({ data }) => {
          this.body = "";
          this.isOpen = false;

          flash("Your reply has been posted!");

          this.$emit("addedReply", data);
        });
    },
    // openModal() {
    //   this.isOpen = true;
    //   this.$nextTick(() => this.$refs.textArea.focus());
    // },
  },
};
</script>

<style lang="scss" scoped>
</style>