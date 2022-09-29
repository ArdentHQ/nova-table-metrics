<script setup>
import { ref } from "vue";
import TableRow from "./TableRow.vue";

const props = defineProps(["card"]);

const currentRange = ref(
    props.card.ranges.filter((range) => range.value === props.card.range)[0]
);
const loading = ref(false);
const items = ref(props.card.items);

const changeRange = (range) => {
    if (!props.card.hasRanges) {
        return;
    }

    currentRange.value = props.card.ranges.filter((r) => r.value === range)[0];
    loading.value = true;

    Nova.request()
        .get(
            `/nova-vendor/nova-table-metrics?card=${props.card.uriKey}&range=${range}`
        )
        .then(({ data }) => {
            items.value = data;
            loading.value = false;
        });
};
</script>

<template>
    <LoadingCard :loading="loading">
        <header class="flex items-center justify-between p-4">
            <h3 class="text-gray-800 w-full font-semibold dark:text-white">
                {{ card.title }}
                <template v-if="card.hasRanges"
                    >({{ currentRange.label.toLowerCase() }})</template
                >
            </h3>

            <SelectControl
                v-if="card.hasRanges"
                class="ml-auto w-[10rem] flex-shrink-0"
                size="xs"
                :options="card.ranges"
                :selected="currentRange.value"
                @change="changeRange"
                :aria-label="__('Select Ranges')"
            />
        </header>

        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="font-semibold p-4 text-left text-xs">
                        {{ card.heading }}
                    </th>
                    <th class="font-semibold p-4 text-right text-xs">
                        {{ card.detail }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <TableRow v-for="row in items" :row="row" :key="index" />
            </tbody>
        </table>
    </LoadingCard>
</template>
