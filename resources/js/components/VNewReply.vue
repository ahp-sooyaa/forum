<template>
  <div v-show="isOpen" class="mb-3">
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

        <div class="hidden">
          <label class="sr-only">Don’t fill this out if you're human: </label>
          <input v-model="bot" name="bot-field" placeholder="This field is only for the robots." 
            class="form-input block w-full py-3 px-4 placeholder-gray-500 transition ease-in-out duration-150"
          />
        </div>
        <div class="mb-3">
          <textarea
            id="body" name="body"
            rows="6" class="text-white border-0 focus:ring-0 block w-full sm:text-sm bg-gray-700 px-0"
            v-model="body" ref="textArea"
          ></textarea>
        </div>
        <vue-recaptcha
            ref="recaptcha"
            @verify="onCaptchaVerified"
            @expired="resetCaptcha"
            size="invisible"
            sitekey="6LcEHLYaAAAAAGLAYvJ_TeGR3y0FjT0AbLjGIHvj">
        </vue-recaptcha>

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
import VueRecaptcha from 'vue-recaptcha';

export default {
  components: {VueRecaptcha},
  
  data() {
    return {
      isOpen: false,
      bot: null,
      body: "",
      endPoint: location.pathname + "/replies",
    };
  },

  created() {
    window.events.$on("reply", this.openModal);
  },

  mounted() {
    let tribute = new Tribute({
      // column to search against in the object (accepts function or string)
      lookup: "value",
      // column that contains the content to insert by default
      fillAttr: "value",
      values: function (query, cb) {
        axios.get("/api/users", { params: { name: query } })
          .then(function (response) {
            cb(response.data);
          });
      },
    });
    tribute.attach(document.getElementById("body"));
  },

  methods: {
    addReply() {
      // checking honeypot pattern field
      if(this.bot != null)
      {
        flash("Bot detected! Are You Bot?", 'red')
      } 
      else 
      {
        this.$refs.recaptcha.execute()
      }
    },
    onCaptchaVerified(token) {
        this.resetCaptcha()

        let fData = new FormData()
        fData.append('body', this.body)
        fData.append('g-recaptcha-response', token)

        axios.post(this.endPoint, fData)
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
    resetCaptcha() {
        this.$refs.recaptcha.reset()
    },
    openModal() {
      this.isOpen = true;
      this.$nextTick(() => this.$refs.textArea.focus());
    },
  },
};
</script>

<style lang="scss" scoped>
</style>