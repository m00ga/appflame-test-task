declare global {
    type ApiRouteMethod = 'index' | 'store';
    type ApiRouteEndpoint = string | ((...params) => string);

    type ApiRouteGroup = Partial<Record<ApiRouteMethod, ApiRouteEndpoint>>;
}

export {}
