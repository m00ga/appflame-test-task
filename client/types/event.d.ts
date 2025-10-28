export type EventType = 'page_view' | 'cta_click' | 'form_submit';

export type TodayStatsResponse = {
    date: string;
    counts: {
        [key in EventType]: number;
    };
    total: number;
};
