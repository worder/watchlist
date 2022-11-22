import 'core-js/actual';
import 'regenerator-runtime/runtime';

import ReactDOM from 'react-dom';
import React from 'react';
import Root from 'app/Root';
import { BrowserRouter } from 'react-router-dom';
import { hot } from 'react-hot-loader/root';

const App = hot(() => (
    <BrowserRouter>
        <Root />
    </BrowserRouter>
));

document.addEventListener('DOMContentLoaded', () => {
    ReactDOM.render(<App />, document.getElementById('app-root'));
});
