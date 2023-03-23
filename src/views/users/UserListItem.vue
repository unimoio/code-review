<template>
  <div class="user-item" :class="{ selected: selectedId === user.id }">
    <Card class="user-item" @click="handleUserOpen">
      <template #slot1>{{ user.avatar }}</template>
      <template #slot2>{{ user.name }}</template>
      <template #slot3></template>
    </Card>
    <button v-if="selectedId === user.id" class="button_delete" @click="handleUserDelete">Delete user</button>
  </div>
</template>

<script lang="ts" setup>
  import { defineProps, defineEmits } from 'vue';
  import API from '@/api';

  import Card from '@/components/Card.vue';

  import { User } from '@/components/types/User';

  const props = defineProps<{
    user: User;
    selectedId: number;
  }>();

  const emitUserCardEvent = defineEmits(['on-user-delete', 'on-error', 'on-user-open']);

  const handleUserOpen = () => {
    emitUserCardEvent('on-user-open', props.user);
  };

  const handleUserDelete = () => {
    API.post('/users/delete', { id: props.selectedId })
      .then(() => {
        emitUserCardEvent('on-user-delete', props.user);
      })
      .catch((err: any) => {
        emitUserCardEvent('on-error', err);
      });
  };
</script>

<style lang="scss" scoped></style>
