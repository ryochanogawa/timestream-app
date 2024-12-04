const middleware = {}

middleware['auth'] = require('../src/middleware/auth.ts')
middleware['auth'] = middleware['auth'].default || middleware['auth']

middleware['guest'] = require('../src/middleware/guest.ts')
middleware['guest'] = middleware['guest'].default || middleware['guest']

export default middleware
