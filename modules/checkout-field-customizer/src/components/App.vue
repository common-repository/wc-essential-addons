<template>
  <div>
    <Head :fields="fields" :target="target" />
    <Section :sections="sections" @section="changeSection" />
    <button
      @click="$modal.show('createForm')"
      style="margin-bottom: 15px;"
      class="sdevs-button cfc-primary-button"
    >
      ADD NEW
    </button>
    <!-- <div class="cfc-card-row">
      <div class="col"><Card /></div>
      <div class="col"><Card /></div>
    </div> -->
    <draggable v-model="fields">
      <transition-group>
        <Card
          v-for="(field, index) in fields"
          :key="'card-' + index"
          :field="field"
          :index="index"
        />
      </transition-group>
    </draggable>
    <Edit v-on:updated="changeData" :target="target" />
    <Create v-on:updated="changeData" :target="target" />
    <Column :fields="fields" />
  </div>
</template>

<script>
import Head from "./Head";
import Section from "./Section";
import Card from "./Card";
import Edit from "./Edit";
import Create from "./Create";
import Column from "./Column";
import draggable from "vuedraggable";
export default {
  name: "App",
  data() {
    return {
      target: "cfc_billing_fields",
      sections: [
        {
          name: "billing",
          label: "Billing Fields",
          target_fields: "cfc_billing_fields",
        },
        {
          name: "shipping",
          label: "Shipping Fields",
          target_fields: "cfc_shipping_fields",
        },
        {
          name: "order",
          label: "Order Fields",
          target_fields: "cfc_order_fields",
        },
      ],
      fields: [],
      tabs: [
        {
          label: "Labels",
          key: "cfc_checkout_label_tab",
          fields: [
            {
              row: [
                {
                  label: "Label",
                  type: "text",
                  name: "label",
                  placeholder: "Enter Label",
                  value: null,
                },
                {
                  label: "Placeholder (optional)",
                  type: "text",
                  name: "placeholder",
                  placeholder: "Enter placeholder",
                  value: null,
                },
              ],
            },
            {
              label: "Default Value (optional)",
              type: "text",
              name: "value",
              placeholder: "Enter default value",
              value: null,
            },
          ],
        },
        {
          label: "Settings",
          key: "cfc_checkout_settings_tab",
          fields: [
            {
              row: [
                {
                  label: "Type",
                  type: "select",
                  name: "type",
                  value: "text",
                  options: [
                    { text: "Text" },
                    { tel: "Phone" },
                    { email: "Email" },
                    { password: "Password" },
                    { select: "Select" },
                    { textarea: "Textarea" },
                    { radio: "Radio" },
                  ],
                },
                {
                  label: "Name",
                  type: "text",
                  name: "key",
                  placeholder: "Name must be unique !!",
                  value: null,
                },
              ],
            },
            {
              row: [
                {
                  label: "Status",
                  type: "select",
                  name: "status",
                  value: "enable",
                  options: [{ enable: "Enable" }, { disable: "Disable" }],
                },
                {
                  label: "Required",
                  type: "select",
                  name: "required",
                  value: "yes",
                  options: [{ yes: "Yes" }, { no: "No" }],
                },
              ],
            },
            {
              row: [
                {
                  label: "Display in Emails",
                  type: "select",
                  name: "display_in_email",
                  value: "yes",
                  options: [{ yes: "Yes" }, { no: "No" }],
                },
                {
                  label: "Display in Order Detail Pages",
                  type: "select",
                  name: "display_in_order",
                  value: "yes",
                  options: [{ yes: "Yes" }, { no: "No" }],
                },
              ],
            },
            {
              label: "Options",
              type: "multi",
              conditional: true,
              target_field: "type",
              name: "options",
              values: ["select", "radio"],
            },
          ],
        },
        {
          label: "Styling",
          key: "cfc_checkout_style_tab",
          fields: [
            {
              label: "Class",
              type: "text",
              name: "class",
              placeholder: "Enter class name",
              value: "form-row-wide",
            },
          ],
        },
      ],
    };
  },
  methods: {
    changeSection(section) {
      this.target = section.target_fields;
      this.getData();
    },
    changeData() {
      this.getData();
    },
    getData() {
      let formData = {
        action: "cfc_get_fields",
        target: this.target,
      };
      let root = this;
      axios
        .post(sdwac_coupon_helper_obj.ajax_url, Qs.stringify(formData))
        .then((response) => {
          root.fields = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getData();
  },
  components: {
    Head,
    Section,
    Card,
    Edit,
    draggable,
    Column,
    Create,
  },
};
</script>
