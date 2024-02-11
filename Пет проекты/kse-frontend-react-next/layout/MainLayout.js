export function MainLayout({children}) {
    return (
        <>
        <div className="flex w-full justify-between border border-black">
            <h1 className="mb-5 text-3xl underline border border-black">fdsds</h1>
            <h1 className="mb-3 text-3xl underline">fdsds</h1>
            <h1 className="mb-3 text-3xl underline">fdsds</h1>
            <h1 className="mb-3 text-3xl underline">fdsds</h1>
        </div>
        <main>
            {children}
        </main>
       
        </>
    )
}