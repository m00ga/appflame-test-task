<script setup lang="ts">
import type {EventType} from "~/types/event";
import useTodayStats from "~/composables/api/useTodayStats";

const {sendEvent} = useAnalytics();
const toast = useToast();
const {refreshFetchIndex} = useTodayStats();

const eventSendHandler = async (type: EventType) => {
  const result = await sendEvent(type);
  await refreshFetchIndex();
  toast.add({
    title: toastMessages[result.status as ToastSeverity],
    description: result.message,
    duration: 2000,
  });
};
</script>

<template>
  <UCard variant="subtle">
    <template #header>
      <span class="text-lg">Actions</span>
    </template>

    <UContainer class="grid gap-4 xs:grid-rows-3 md:grid-cols-3">
      <UButton @click="eventSendHandler('page_view')" size="lg" color="neutral" variant="soft">page_view</UButton>
      <UButton @click="eventSendHandler('cta_click')" size="lg" color="neutral" variant="soft">cta_click</UButton>
      <UButton @click="eventSendHandler('form_submit')" size="lg" color="neutral" variant="soft">form_submit</UButton>
    </UContainer>
  </UCard>
</template>
