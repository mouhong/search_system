# Search system

## 前台网站 (src/web)

### 数据访问 (app/data)

1. `Repository`封装了单个对象的数据访问，其`query`方法提供了一个基本的 Fluent 查询接口;
2. `Repository`的`create`和`update`方法用于创建和更新对象，使用了反射 (未优化)，`update`可能有并发更新问题，可做 Optimistic concurrency control (未实现);

### Messaging (app/messaging)

1. `app/messaging/messages`中存放业务相关的事件/消息 (Domain Event);
2. 用户创建后发布`UserCreated`消息到 RabbitMQ，创建用户的代码不关注是否新加的用户数据会添加到 ElasticSearch 中;
3. 成功添加用户数据到 MySQL 后，发布`UserCreated`消息可能失败，如果要考虑这种情形，可能需要在 MySQL 中建一个“本地”的消息队列，以保证消息不丢失 (未实现);

### Services (app/services)

仅充当一个 Facade 的作用。

## Search worker (src/search_worker)

1. `main.js`为程序入口;
2. 为了让用户代码订阅消息更简单一点 (不需要理解 RabbitMQ)，`events.js`充当了“桥梁”的作用，先接收 RabbitMQ 的消息，然后转化为普通的消息对象转发给用户代码 (`consumers.js`)，因此不管是 web 端还是 search worker，用户代码接触到的都是“领域事件” (普通对象);



