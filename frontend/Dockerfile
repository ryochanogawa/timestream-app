# frontend/Dockerfile
FROM node:18-alpine

WORKDIR /app

# グローバルパッケージのインストール
RUN npm install -g npm@latest

# パッケージファイルをコピー
COPY ./src/package*.json ./

# 依存関係のインストール
RUN npm install

# 残りのソースコードをコピー
COPY ./src .

# ポートの設定
EXPOSE 3000

# 起動コマンド
CMD ["npm", "run", "dev"]