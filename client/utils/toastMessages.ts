const defineToastMessages = <T extends Record<ToastSeverity, string>>(messages: T) => messages;

export default defineToastMessages({
    info: "Info message",
    warning: "Warning message",
    error: "Error message"
});
