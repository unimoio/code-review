<template>
  <div class="card">
    <div class="card__image">
      <slot name="slot1"></slot>
    </div>
    <div class="card__info">
      <div class="card__title">
        <slot name="slot2"></slot>
      </div>
      <div class="card__description">
        <slot name="slot3"></slot>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import AppImage from '@/components/AppImage.vue';
</script>

<style lang="scss">
  .card {
    padding: 16px;
    display: flex;
    align-items: center;
  }

  .card__image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 16px;
  }

  .card__info {
    flex: 1 1 auto;
  }

  .card__title {
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
    margin-bottom: 4px;
  }

  .card__description {
    font-size: 14px;
    line-height: 1.5;
    color: #6e6e6e;
  }
</style>
