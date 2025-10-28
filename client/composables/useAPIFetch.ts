import {useRuntimeConfig} from "#app";

type fetchType<T> = typeof $fetch<T>;

export function useAPIFetch<T = unknown>(
    url: string,
    opts?: Parameters<fetchType<T>>[1]
) {
    const config = useRuntimeConfig();
    const fullApiURL = config.public.apiBase.trimEnd() + `/${config.public.apiVersion}`;

    return $fetch<T>(url, {
        ...opts,
        onRequest ({options}) {
            if (config.public.apiSecret) {
                options.headers.append('Authorization', `Bearer ${config.public.apiSecret}`)
            }
        },
        baseURL: fullApiURL
    })
}
