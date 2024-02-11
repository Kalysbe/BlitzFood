import Link from 'next/link'

export default function ErrorPage() {
    return (
        <>
         <h1>error 404</h1>
         <p>пожалуйса <Link href='/'>вернитесь на главную страницу</Link> </p>
        </>
    )
}