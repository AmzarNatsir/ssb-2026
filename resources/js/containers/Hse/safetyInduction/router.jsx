import React, { Suspense, lazy } from 'react';
import ReactDOM from 'react-dom';
import {
    MemoryRouter,
    Routes,
    Route
} from 'react-router-dom'
import {
    QueryClient,
    QueryClientProvider
} from '@tanstack/react-query'

import { ReactQueryDevtools } from '@tanstack/react-query-devtools'

import { Provider } from 'react-redux';
import { store } from '../../../store';

const IndexPage = lazy(() => import('./index'));
const queryClient = new QueryClient()

const HseRouter = () => {
    return (
        <QueryClientProvider client={queryClient}>
            <Provider store={store}>
                <MemoryRouter initialEntries={["/"]}>
                    <Suspense fallback={<div>Loading...</div>}>
                        <Routes>
                            <Route path="" element={<IndexPage />} />
                        </Routes>
                    </Suspense>
                </MemoryRouter>
            </Provider>
            <ReactQueryDevtools initialIsOpen={false} />
        </QueryClientProvider>
    )
}

export default HseRouter;

if (document.getElementById('index2-dom')) {
    const elem = document.getElementById('index2-dom')
    ReactDOM.render(<HseRouter />, elem);
}