<script setup lang="ts">
import type { NuxtError } from '#app';

defineProps<{
  error: NuxtError;
}>();

useHead({
  htmlAttrs: {
    lang: 'en',
  },
});

useSeoMeta({
  title: 'Ошибка',
});

const { data: navigation } = await useAsyncData('navigation', () => queryCollectionNavigation('docs'));
const { data: files } = useLazyAsyncData('search', () => queryCollectionSearchSections('docs'), {
  server: false,
});

provide('navigation', navigation);
</script>

<template>
  <UApp>
    <AppHeader />

    <UError
      :error="error"
      :clear="{ label: 'Вернуться на главную' }"
    />

    <ClientOnly>
      <LazyUContentSearch
        :files="files"
        :navigation="navigation"
      />
    </ClientOnly>
  </UApp>
</template>
