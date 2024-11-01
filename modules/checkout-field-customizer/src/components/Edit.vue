<template>
  <modal name="editForm" height="500" :draggable="true" @before-open="setData">
    <div class="cfc-admin-form sdevs-form">
      <div class="cfc-modal-titlebar">
        <strong>Checkout forums</strong>
        <svg
          @click="closeSetting"
          width="16"
          height="16"
          xmlns="http://www.w3.org/2000/svg"
          class="ionicon cfc-icon"
          viewBox="0 0 512 512"
        >
          <title>Close</title>
          <path
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
            d="M368 368L144 144M368 144L144 368"
          />
        </svg>
      </div>
      <Options v-on:option-fields="getFields" :tabs="tabs" :form="Afields" />
      <div class="cfc-form-fields">
        <div v-for="(field, index) in fields" :key="index">
          <div class="cfc-admin-form-row" v-if="field.row">
            <div
              v-for="(rowfield, rowindex) in field.row"
              :key="'rowf-' + rowindex"
            >
              <div
                v-if="rowfield.type !== 'select' && rowfield.type !== 'multi'"
              >
                <Input
                  v-model="Afields[rowfield.name]"
                  :field="rowfield"
                  :from="Afields.from"
                />
              </div>
              <div v-else-if="rowfield.type === 'select'">
                <Select
                  v-on:selectInputData="changeVisible"
                  v-model="Afields[rowfield.name]"
                  :field="rowfield"
                  :from="Afields.from"
                />
              </div>
            </div>
          </div>
          <div v-else>
            <div v-if="field.type !== 'select' && field.type !== 'multi'">
              <Input
                v-model="Afields[field.name]"
                :field="field"
                :from="Afields.from"
              />
            </div>
            <div v-else-if="field.type === 'select'">
              <Select
                v-on:selectInputData="changeVisible"
                v-model="Afields[field.name]"
                :field="field"
                :from="Afields.from"
              />
            </div>
            <div v-else-if="field.type === 'multi'">
              <div class="cfc-admin-form-col" v-if="visible">
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
                    <button
                      @click="cloneFields()"
                      class="sdevs-button cfc-primary-button"
                    >
                      <svg
                        style="position: relative; top: 4px;"
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
                      v-if="option_fields.length > 1"
                      class="sdevs-button cfc-danger-button"
                    >
                      <svg
                        style="position: relative; top: 4px;"
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
            </div>
          </div>
        </div>
        <div class="cfc-admin-form-buttons">
          <button @click="updateForm" class="sdevs-button cfc-primary-button">
            Update
          </button>
          <button
            v-if="Afields.from === 'custom'"
            @click="deleteField()"
            class="sdevs-button cfc-danger-button"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import Options from "./Options";
import Input from "./forms/Input";
import Select from "./forms/Select";
export default {
  name: "Edit",
  props: ["target"],
  data() {
    return {
      tabs: [],
      fields: [],
      Afields: {
        from: "custom",
      },
      option_fields: [
        {
          option_label: null,
          option_value: null,
        },
      ],
      visible: false,
      index: 0,
    };
  },
  methods: {
    setData(data) {
      const params = data.params;
      this.index = params.index;
      if (
        typeof params.field.options == "object" &&
        params.field.type == "select" &&
        params.field.options.length > 0
      ) {
        this.option_fields = params.field.options;
        this.visible = true;
      } else {
        this.option_fields = [
          {
            option_label: null,
            option_value: null,
          },
        ];
        this.visible = false;
      }
      this.getAllFields(params.field);
    },
    changeVisible(data) {
      if (data === "select" || data === "radio") this.visible = true;
    },
    emmitData() {
      this.Afields.options = this.option_fields;
    },
    closeSetting() {
      this.$modal.hide("editForm");
    },
    getFields(fields) {
      if (typeof fields === "object") this.fields = fields;
    },
    getAllFields(field = false) {
      let tabs = this.tabs;
      for (let index = 0; index < tabs.length; index++) {
        const element = tabs[index];
        for (let findex = 0; findex < element.fields.length; findex++) {
          const felement = element.fields[findex];
          if (felement.row) {
            for (let rowindex = 0; rowindex < felement.row.length; rowindex++) {
              const rowelement = felement.row[rowindex];
              this.Afields[rowelement.name] = rowelement.value;
              if (field) {
                this.Afields[rowelement.name] = field[rowelement.name];
                this.Afields.from = field.from;
              }
            }
          } else {
            this.Afields[felement.name] = felement.value;
            if (field) {
              this.Afields[felement.name] = field[felement.name];
              this.Afields.from = field.from;
            }
          }
        }
      }
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
    updateForm() {
      let formData = {
        action: "cfc_update_field",
        data: this.Afields,
        target: this.target,
        nonce: cfc_helper_obj.nonce,
        index: this.index,
      };
      let root = this;
      axios
          .post(sdwac_coupon_helper_obj.ajax_url, Qs.stringify(formData))
        .then((response) => {
          if (response.data.type === "error") {
            this.$swal.fire({
              icon: "error",
              title: "ERROR !!",
              text: response.data.msg,
            });
          } else {
            this.$swal.fire({
              icon: "success",
              title: "SUCCESS !!",
              text: response.data.msg,
            });
            root.fields = [];
            root.Afields = {};
            root.option_fields = [
              {
                option_label: null,
                option_value: null,
              },
            ];
            root.visible = false;
            this.$emit("updated", "created");
            this.$modal.hide("editForm");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getData() {
      let formData = {
        action: "cfc_get_admin_fields",
        nonce: cfc_helper_obj.nonce,
      };
      let root = this;
      axios
        .post(sdwac_coupon_helper_obj.ajax_url, Qs.stringify(formData))
        .then((response) => {
          root.tabs = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteField() {
      let formData = {
        action: "cfc_delete_field",
        target: this.target,
        nonce: cfc_helper_obj.nonce,
        index: this.index,
      };
      let root = this;
      axios
          .post(sdwac_coupon_helper_obj.ajax_url, Qs.stringify(formData))
          .then((response) => {
            if (response.data.type === "error") {
              this.$swal.fire({
                icon: "error",
                title: "ERROR !!",
                text: response.data.msg,
              });
            } else {
              this.$swal.fire({
                icon: "success",
                title: "SUCCESS !!",
                text: response.data.msg,
              });
              root.fields = [];
              root.Afields = {};
              root.option_fields = [
                {
                  option_label: null,
                  option_value: null,
                },
              ];
              root.visible = false;
              this.$emit("updated", "created");
              this.$modal.hide("editForm");
            }
          })
          .catch((error) => {
            console.log(error);
          });
    }
  },
  mounted() {
    this.getAllFields();
    this.getData();
  },
  components: {
    Options,
    Input,
    Select,
  },
};
</script>
