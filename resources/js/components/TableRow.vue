<script setup>
defineProps({
    row: Object,
})
</script>

<template>
    <tr>
        <td class="p-4">
            <p>
                <a :href="row.url" v-if="row.url" class="link-default" :target="row.openInNewTab ? '_blank' : null">{{ row.title }}</a>
                <template v-else>{{ row.title }}</template>
            </p>
        </td>

        <td class="text-right p-4">{{ row.detail }}</td>
    </tr>
</template>
