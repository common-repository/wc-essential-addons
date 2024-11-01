<template>
  <modal
    name="column_selection"
    height="500"
    :draggable="true"
    @before-open="getParams"
  >
    <ul class="cfc-column-lists">
      <li v-for="(field, index) in filtered_fields" :key="index">
        {{ field.label ? field.label : field.key }}
      </li>
    </ul>
  </modal>
</template>

<script>
export default {
  name: "Column",
  props: ["fields"],
  data() {
    return {
      filtered_fields: [],
    };
  },
  methods: {
    getParams(data) {
      let current_field_key = data.params;
      let filtered_fields = [];
      this.fields.forEach((field) => {
        if (field.key != current_field_key) filtered_fields.push(field);
      });
      this.filtered_fields = filtered_fields;
    },
  },
};
</script>