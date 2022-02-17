import 'core-js/stable';
import 'regenerator-runtime/runtime';

import ReactDOM from 'react-dom';
import React from 'react';
import Root from 'app/Root';
import { BrowserRouter } from 'react-router-dom';

document.addEventListener('DOMContentLoaded', () => {
    ReactDOM.render(
        <BrowserRouter>
            <Root />
        </BrowserRouter>,
        document.getElementById('app-root')
    );
});
