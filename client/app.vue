<script setup lang="ts">
import useTodayStats from "~/composables/api/useTodayStats";

const {fetchIndex} = useTodayStats();
const response = await fetchIndex();

console.log(response.data.value);

</script>

<template>
  <div>
    <NuxtRouteAnnouncer />
    <NuxtWelcome />
  </div>
</template>
