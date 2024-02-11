import {Header} from './components/header/header'
import { Footer } from '../components/Footer/Footer'

export function MainLayout({children}) {
    return (
        <>
        <nav>
            <Header/>
        </nav>
        <main>
            {children}
        </main>
        <footer>   
            <Footer/>
        </footer>
        </>
    )
}