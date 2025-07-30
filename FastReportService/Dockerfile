FROM mcr.microsoft.com/dotnet/aspnet:6.0 AS base
WORKDIR /app
EXPOSE 80

# Install libgdiplus for System.Drawing.Common
RUN apt-get update && apt-get install -y libgdiplus libc6-dev
RUN apt-get install -y fonts-dejavu-core
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

FROM mcr.microsoft.com/dotnet/sdk:6.0 AS build
WORKDIR /src
COPY ["FastReportService.csproj", "."]
RUN dotnet restore "FastReportService.csproj"
COPY . .
RUN dotnet build "FastReportService.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "FastReportService.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
COPY reports /app/reports
ENTRYPOINT ["dotnet", "FastReportService.dll"]