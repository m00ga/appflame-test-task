import type {EventSendResponse, EventType} from "~/types/event";

export default function () {
    const useSession = () => {
        const storageKey = 'session_id';

        const sessionState = useState('session_id', () => <string>crypto.randomUUID());

        onMounted(() => {
            let saved = localStorage.getItem(storageKey);
            if (!saved) {
                saved = crypto.randomUUID();
                localStorage.setItem(storageKey, saved);
            }
            sessionState.value = saved;
        });

        return sessionState;
    };

    const useTimestamp = () => {
        const dayjs = useDayjs()();
        if (config.public.timezone) {
            dayjs.tz(config.public.timezone);
        }
        return dayjs.toISOString();
    }

    const sessionId = useSession();
    const config = useRuntimeConfig();

    return {
        sessionId,
        sendEvent: async function (type: EventType) {
            const ts = useTimestamp();

            return (await $fetch<EventSendResponse>('/api/sendEvent', {
                method: 'POST',
                body: {
                    type,
                    ts,
                    session_id: sessionId.value
                }
            }));
        }
    };
};
