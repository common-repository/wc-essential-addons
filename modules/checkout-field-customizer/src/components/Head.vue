<template>
  <div class="cfc-header">
    <h3>Checkout forums</h3>
    <button @click="submitFields" class="sdevs-button cfc-primary-button">
      Save Changes
    </button>
  </div>
</template>

<script>
export default {
  name: "Head",
  props: ["fields", "target"],
  methods: {
    submitFields() {
      let formData = {
        action: "cfc_update_fields",
        fields: this.fields,
        target: this.target,
        nonce: sdwac_coupon_helper_obj.nonce,
      };
      axios
        .post(sdwac_coupon_helper_obj.ajax_url, Qs.stringify(formData))
        .then((response) => {
          if (response.data.type === "success") {
            this.$swal.fire({
              icon: "success",
              title: "SUCCESS !!",
              text: response.data.msg,
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
