<template>
    <tr :class="getClass">
      <td v-for="(header, index) in headers" :key="index">
        <slot :item="item" :name="columnName(header)">
          <div :style="getAlignment(header)">
            {{ getNonSlotValue(item, header) }}
          </div>
        </slot>
      </td>
    </tr>
  </template>

  <script>
  export default {
    name: "DataTableRowHandler",
    components: {},
    props: {
      itemClass: {
        type: String,
        default: "",
      },
      item: {
        type: Object,
        default: () => {
          return {};
        },
      },
      headers: {
        type: Array,
        default: () => {
          return [];
        },
      },
    },
    data() {
      return {};
    },
    computed: {
      getClass() {
        return this.itemClass;
      }
    },
    methods: {
      columnName(header) {
        return `item.${header.value}`;
      },
      getAlignment(header) {
        const align = header.align ? header.align : "right";
        return `text-align: ${align}`;
      },
      getNonSlotValue(item, header) {
        const val = item[header.value];

        if (val) {
          return val;
        }

        return "";
      },
    },
  };
  </script>
  <style scoped>
  .handle {
    cursor: move;
  }
  tbody tr:nth-of-type(even) {
    background-color: rgba(0, 0, 0, 0.01);
  }
  tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
  }
  .pprint {
    white-space:pre-wrap;
    word-wrap:break-word;
  }
  </styl
