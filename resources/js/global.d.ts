export {}; // Убедитесь, что файл является модулем

declare global {
  interface Window {
    authToken: string; // Добавляем свойство authToken в тип Window
  }
}