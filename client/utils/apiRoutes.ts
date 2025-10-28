const defineApiRoutes = <T extends Record<string, ApiRouteGroup>>(routes: T) => routes;

export default defineApiRoutes({
    todayStats: {
        index: 'stats/today'
    }
});
