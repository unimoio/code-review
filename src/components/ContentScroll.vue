<template>
  <div class="content-scroll" @scroll="handleScroll">
    <slot></slot>
  </div>
</template>

<script lang="ts" setup>
  import { defineEmits, ref } from 'vue';

  const emit = defineEmits(['load-more']);

  const canEmitEvent = ref(false);

  const handleScroll = () => {
    if (canEmitEvent.value) {
      emit('load-more');
    }
  };
</script>

<style lang="scss" scoped>
  .content-scroll {
    overflow-y: auto;
    height: 100%;

    ::v-deep {
      > * {
        margin-top: 16px;
        border-radius: 8px;
      }
    }
  }
</style>
