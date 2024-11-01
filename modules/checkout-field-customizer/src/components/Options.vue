<template>
  <div class="cfc-form-options">
    <ul>
      <li v-for="(tab, index) in tabs" :key="index">
        <a
          @click="tabSelect(index)"
          :class="index === seIndex ? 'active' : null"
          href="javascript:void(0);"
          >{{ tab.label }}</a
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "Options",
  props: ["tabs", "form"],
  data() {
    return {
      seIndex: 0,
    };
  },
  methods: {
    tabSelect(index) {
      this.seIndex = index;
      let fields = this.tabs[index].fields;
      for (let lindex = 0; lindex < fields.length; lindex++) {
        let element = fields[lindex];
        if (element.row) {
          for (let rowindex = 0; rowindex < element.row.length; rowindex++) {
            const rowelement = element.row[rowindex];
            rowelement.value = this.form[rowelement.name];
          }
        } else {
          element.value = this.form[element.name];
        }
      }
      this.$emit("option-fields", fields);
    },
  },
  mounted() {
    this.tabSelect(0);
  },
};
</script>
