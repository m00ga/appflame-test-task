<script setup lang="ts">
import useTodayStats from "~/composables/api/useTodayStats";

let intervalId: number | undefined;

const {fetchIndex} = useTodayStats();
const toast = useToast();

const {data, pending, refresh} = await fetchIndex();

onMounted(() => {
  intervalId = setInterval(async () => {
    await refresh();
    toast.add({
      title: 'Today stats was updated',
      duration: 2000
    });
  }, 10000);
});

onUnmounted(() => clearInterval(intervalId));
</script>

<template>
  <UCard variant="subtle">
    <template #header>
      <span class="text-lg">Today stats</span>
    </template>

    <div v-if="pending && !data" class="flex justify-center items-center py-8">
      <UProgress animation="carousel" class="w-full max-w-xs"/>
      <span class="ml-4 text-gray-500">Loading today's stats...</span>
    </div>

    <div class="grid grid-rows-[1fr_max-content] gap-4" v-else>
      <div class="grid gap-4 xs:grid-rows-3 md:grid-cols-3">
        <UCard variant="soft" v-for="(value, key) in data?.counts">
          <template #header>
            <span>{{ key }}</span>
          </template>
          <span>{{ value }}</span>
        </UCard>
      </div>
      <UCard variant="soft" class="md:mx-[10%]">
        <template #header>
          <span>Total</span>
        </template>
        <span>{{ data?.total }}</span>
      </UCard>
    </div>
  </UCard>
</template>
