import React from 'react';
import { render } from 'react-dom';
import AppStore from './stores/AppStore';
import App from './components/App';
import { Provider } from 'mobx-react';
import  { useStrict } from 'mobx';
import 'babel-polyfill';
import 'whatwg-fetch';

const appStore = new AppStore();
useStrict(true);

render(
    <Provider appStore={appStore}>
        <App />
    </Provider>,
    document.getElementById('root')
);