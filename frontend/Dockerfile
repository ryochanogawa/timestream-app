FROM node:18-alpine

WORKDIR /app

# 必要なツールをインストール
RUN apk add --no-cache git

# グローバルの依存関係をインストール
RUN npm install -g npm@latest

# コンテナ起動時のコマンド
CMD ["sh", "-c", "npm install && npm run dev"]