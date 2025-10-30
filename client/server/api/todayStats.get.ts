import {TodayStatsResponse} from "~/types/event";
import {useAPIFetch} from "~/composables/useAPIFetch";
import apiRoutes from "~/utils/apiRoutes";

export default defineEventHandler((event) => {
    return useAPIFetch<TodayStatsResponse>(
        apiRoutes.todayStats.index
    );
});
