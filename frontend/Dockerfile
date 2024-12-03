# # frontend/Dockerfile
# FROM node:18-alpine

# WORKDIR /app

# # グローバルパッケージのインストール
# RUN npm install -g npm@latest

# # パッケージファイルをコピー
# COPY ./src/package*.json ./

# # 依存関係のインストール
# RUN npm install

# # 残りのソースコードをコピー
# COPY ./src .

# # ポートの設定
# EXPOSE 3000

# # 起動コマンド
# CMD ["npm", "run", "dev"]

# FROM node:18-alpine

# WORKDIR /app

# # package.jsonをコピー
# COPY ./src/package*.json ./

# # 依存関係をインストール
# RUN npm install

# # ソースコードをコピー
# COPY ./src .

# # 開発サーバーのポート
# EXPOSE 3000

# # 開発サーバーを起動
# CMD ["npm", "run", "dev"]


FROM node:16-alpine

WORKDIR /app

# パッケージファイルをコピー
COPY package*.json tsconfig.json ./

# 依存関係のインストール
RUN npm install
RUN npm install --save-dev webpack@4.46.0 webpack-cli@4.9.2

# 残りのソースコードをコピー
COPY . .

# ポートの設定
EXPOSE 3000

# 環境変数の設定
ENV HOST 0.0.0.0
ENV NODE_ENV development

# 起動コマンド
CMD ["npm", "run", "dev"]