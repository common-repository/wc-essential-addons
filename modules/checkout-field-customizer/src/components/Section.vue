<template>
  <div>
    <ul class="section-lists">
      <li v-for="(section, index) in sections" :key="index">
        <a
          :class="active === section.name ? 'cfc-sec-active' : false"
          @click="changeSection(section)"
          href="javascript:void(0)"
          >{{ section.label }}</a
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "Section",
  props: ["sections"],
  data() {
    return {
      active: "billing",
    };
  },
  methods: {
    changeSection(section) {
      if (this.active != section.name) {
        this.active = section.name;
        this.$emit("section", section);
      }
    },
  },
};
</script>