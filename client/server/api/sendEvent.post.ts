import {useAPIFetch} from "~/composables/useAPIFetch";
import apiRoutes from "~/utils/apiRoutes";
import type {EventSendResponse} from "~/types/event";

export default defineEventHandler(async (event) => {
    const idempotencyKey = crypto.randomUUID();
    const body = await readBody(event);
    const config = useRuntimeConfig();

    return useAPIFetch<EventSendResponse>(
        apiRoutes.sendEvent.store,
        {
            method: 'POST',
            body: body,
            headers: {
                [config.idempotentKey]: idempotencyKey
            }
        }
    )
})
