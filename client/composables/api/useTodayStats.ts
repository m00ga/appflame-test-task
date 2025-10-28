import type {TodayStatsResponse} from "~/types/event";

export default function() {
    return {
        fetchIndex: async function() {
            return useAsyncData('todayStatsIndex', () => useAPIFetch<TodayStatsResponse>(
                apiRoutes.todayStats.index
            ))
        }
    };
};
