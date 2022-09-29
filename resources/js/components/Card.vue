<script setup>
import { ref } from "vue";
import TableRow from "./TableRow.vue";

const props = defineProps(["card"]);

const currentPeriod = ref(
    props.card.periods.filter((period) => period.value === props.card.period)[0]
);
const loading = ref(false);
const items = ref(props.card.items);

const changeRange = (period) => {
    if (!props.card.hasPeriodSelector) {
        return;
    }

    currentPeriod.value = props.card.periods.filter((p) => p.value === period)[0];
    loading.value = true;

    Nova.request()
        .get(
            `/nova-vendor/nova-table-metrics?table=${props.card.uriKey}&period=${period}`
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
                <template v-if="card.hasPeriodSelector"
                    >({{ currentPeriod.label.toLowerCase() }})</template
                >
            </h3>

            <SelectControl
                v-if="card.hasPeriodSelector"
                class="ml-auto w-[10rem] flex-shrink-0"
                size="xs"
                :options="card.periods"
                :selected="currentPeriod.value"
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
