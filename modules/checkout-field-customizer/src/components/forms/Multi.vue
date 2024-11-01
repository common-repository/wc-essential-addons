<template>
  <div class="cfc-admin-form-col">
    <strong>Options</strong>
    <div
      class="cfc-admin-form-row"
      v-for="(field, mindex) in option_fields"
      :key="'list-' + mindex"
    >
      <div class="cfc-admin-form-col">
        <input
          type="text"
          placeholder="Option Value"
          v-model="field.option_value"
          @input="emmitData"
        />
      </div>
      <div class="cfc-admin-form-col">
        <input
          type="text"
          placeholder="Option Text"
          v-model="field.option_label"
          @input="emmitData"
        />
      </div>
      <div class="cfc-admin-form-col cfc-multi-buttons">
        <button @click="cloneFields()" class="sdevs-button cfc-primary-button">
          <svg
            style="position: relative; top: 4px"
            width="18"
            height="18"
            xmlns="http://www.w3.org/2000/svg"
            class="ionicon"
            viewBox="0 0 512 512"
          >
            <title>Add</title>
            <path
              d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z"
              fill="none"
              stroke="currentColor"
              stroke-miterlimit="10"
              stroke-width="32"
            />
            <path
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="32"
              d="M256 176v160M336 256H176"
            />
          </svg>
        </button>
        <button
          @click="removeField(mindex)"
          class="sdevs-button cfc-danger-button"
        >
          <svg
            style="position: relative; top: 4px"
            width="18"
            height="18"
            xmlns="http://www.w3.org/2000/svg"
            class="ionicon"
            viewBox="0 0 512 512"
          >
            <title>Remove</title>
            <path
              d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z"
              fill="none"
              stroke="currentColor"
              stroke-miterlimit="10"
              stroke-width="32"
            />
            <path
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="32"
              d="M336 256H176"
            />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Multi",
  props: ["form", "visible"],
  data() {
    return {
      option_fields: [
        {
          option_label: null,
          option_value: null,
        },
      ],
    };
  },
  methods: {
    emmitData() {
      this.$emit("set-data", this.option_fields);
    },
    cloneFields() {
      this.option_fields.push({
        option_label: null,
        option_value: null,
      });
      let multiBody = document.querySelector(".cfc-form-fields");
      multiBody.scrollTop = multiBody.scrollHeight - multiBody.clientHeight;
    },
    removeField(index) {
      this.option_fields.splice(index, 1);
    },
  },
};
</script>
