export default function() {
    return {
        fetchIndex: async function() {
            return useAsyncData('todayStatsIndex', () => useAPIFetch(
                apiRoutes.todayStats.index
            ))
        }
    };
};
