import type {TodayStatsResponse} from "~/types/event";

export default function () {
    const fetchIndexKey = 'today_stats_index';

    return {
        fetchIndex: async function () {
            return useAsyncData(fetchIndexKey, () => $fetch<TodayStatsResponse>('/api/todayStats'));
        },
        refreshFetchIndex: async function() {
            await refreshNuxtData(fetchIndexKey);
        }
    };
};
